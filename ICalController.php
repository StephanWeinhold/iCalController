<?php
use Website\Controller\Action;

class ICalController extends Action
{

    /**
     * @param start (string) in iCal-format - date('Ymd\THis', time())
     * @param end (string) in iCal-format - date('Ymd\THis', time())
     *
     * @throws Exception
     *
     * @return true
     */
    public function defaultAction()
    {
        if ($this->getParam('start') && $this->getParam('end')) {

            if ($this->getParam('start') != '') {

                if ($this->getParam('end') != '') {

                    $iCal = "BEGIN:VCALENDAR\r\n";
                    $iCal .= "VERSION:2.0\r\n";
                    $iCal .= "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\r\n";
                    $iCal .= "BEGIN:VEVENT\r\n";
                    $iCal .= "UID:" . md5(uniqid(mt_rand(), true)) . "@your-domain.com\r\n";
                    $iCal .= "DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z\r\n";
                    $iCal .= "DTSTART:" . $this->getParam('start') . "\r\n";
                    $iCal .= "DTEND:" . $this->getParam('end') . "\r\n";
                    $iCal .= "SUMMARY:Physiotherapie\r\n";
                    $iCal .= "END:VEVENT\r\n";
                    $iCal .= "END:VCALENDAR\r\n";

                    // Set content type-header
                    header('Content-type: text/calendar; charset=utf-8');
                    header('Content-Disposition: inline; filename=calendar.ics');

                    echo $iCal;

                    $this->_helper->json(array('success' => true));
                }
                else {
                    throw new Exception('Param \'end\' is empty.', 404);
                }
            }
            else {
                throw new Exception('Param \'start\' is empty.', 404);
            }
        }
        else {
            throw new Exception('Param(s) \'start\' and/or \'end\' is/are missing.', 404);
        }
    }

}
