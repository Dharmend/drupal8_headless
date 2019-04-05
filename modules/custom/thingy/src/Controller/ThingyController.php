<?php

namespace Drupal\thingy\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\thingy\Entity\ThingyInterface;

/**
 * Class ThingyController.
 *
 *  Returns responses for Thingy routes.
 */
class ThingyController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Thingy  revision.
   *
   * @param int $thingy_revision
   *   The Thingy  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($thingy_revision) {
    $thingy = $this->entityManager()->getStorage('thingy')->loadRevision($thingy_revision);
    $view_builder = $this->entityManager()->getViewBuilder('thingy');

    return $view_builder->view($thingy);
  }

  /**
   * Page title callback for a Thingy  revision.
   *
   * @param int $thingy_revision
   *   The Thingy  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($thingy_revision) {
    $thingy = $this->entityManager()->getStorage('thingy')->loadRevision($thingy_revision);
    return $this->t('Revision of %title from %date', ['%title' => $thingy->label(), '%date' => format_date($thingy->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Thingy .
   *
   * @param \Drupal\thingy\Entity\ThingyInterface $thingy
   *   A Thingy  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ThingyInterface $thingy) {
    $account = $this->currentUser();
    $langcode = $thingy->language()->getId();
    $langname = $thingy->language()->getName();
    $languages = $thingy->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $thingy_storage = $this->entityManager()->getStorage('thingy');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $thingy->label()]) : $this->t('Revisions for %title', ['%title' => $thingy->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all thingy revisions") || $account->hasPermission('administer thingy entities')));
    $delete_permission = (($account->hasPermission("delete all thingy revisions") || $account->hasPermission('administer thingy entities')));

    $rows = [];

    $vids = $thingy_storage->revisionIds($thingy);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\thingy\ThingyInterface $revision */
      $revision = $thingy_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $thingy->getRevisionId()) {
          $link = $this->l($date, new Url('entity.thingy.revision', ['thingy' => $thingy->id(), 'thingy_revision' => $vid]));
        }
        else {
          $link = $thingy->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.thingy.translation_revert', ['thingy' => $thingy->id(), 'thingy_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.thingy.revision_revert', ['thingy' => $thingy->id(), 'thingy_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.thingy.revision_delete', ['thingy' => $thingy->id(), 'thingy_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['thingy_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
