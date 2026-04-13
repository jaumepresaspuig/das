<?php

declare(strict_types=1);

/*
 * This file is part of the "das" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Jp\Das\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PollViewHelper extends AbstractViewHelper
{    /**
     * @var ConfigurationManagerInterface
     */
    public function initializeArguments()
    {
        $this->registerArgument('poll', 'integer', 'Uid of the poll', 0, true);
        $this->registerArgument('preview', 'integer', 'If preview', 0, true);
    }
    /**
     * @return array
     */
    public function render(): array
    {

        $return = [
            'results' => [],
            'message' => 'thanks',
            'showAnswersOrResults' => 'answers'
        ];
        if ($this->arguments['preview']) {
            $poll = (int)$this->arguments['poll'];
        } else {
            $poll = (isset($_GET['pk_campaign']) && $_GET['pk_campaign'] !== '')
                  ? (int)$_GET['pk_campaign']
                  : 0;
        }
        $answer = (isset($_GET['pk_kwd']) && $_GET['pk_kwd'] !== '')
                ? (int)$_GET['pk_kwd']
                : 0;
        if ($poll) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
            $res = $queryBuilder
                ->select('tx_das_poll')
                ->from('tt_content')
                ->where(
                    $queryBuilder->expr()->eq('uid', $poll)
                )
                ->executeQuery()
                ->fetchAllAssociative();
            $tx_das_poll = $res[0]['tx_das_poll'];
            if (strpos($tx_das_poll, '-' . $_SERVER['REMOTE_ADDR'] . '-')) {
                $return['showAnswersOrResults'] = 'results';
                $return['message'] = 'nope';
            } elseif ($answer) {
                $tx_das_poll .= '
' . $answer . '-' . $_SERVER['REMOTE_ADDR'] . '-' . time();
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
                $res = $queryBuilder
                    ->update('tt_content')
                    ->set('tx_das_poll', $tx_das_poll)
                    ->where(
                        $queryBuilder->expr()->eq('uid', $poll)
                    )
                    ->executeStatement();
                $return['showAnswersOrResults'] = 'results';
            }
            $resArray = explode("\n", $tx_das_poll);
            foreach ($resArray as $row) {
                $a = explode('-', $row);
                if (!array_key_exists($a[0], $return['results'])) {
                    $return['results'][$a[0]] = [
                        'votes' => 0,
                        'percent' => 0.00
                    ];
                }
                $return['results'][$a[0]]['votes'] += 1;
            }
            $totalVotes = count($resArray);
            foreach ($return['results'] as $key => $value) {
                if ($value['votes'] > 0) {
                    $return['results'][$key]['percent'] = number_format((($value['votes'] / $totalVotes) * 100), 2);
                }
            }
        }
        return $return;
    }
}
