<?php

class Webhook
{

    /**
     * @param $jsonEvent
     */
    public function processEvent($jsonEvent) {
            switch ($jsonEvent->event) {
                case 'processed':
                    $return = $this->handleProcessedEvent($jsonEvent);
                    break;
                case 'clicked':
                    $return = $this->handleClickedEvent($jsonEvent);
                    break;
                case 'delivered':
                    $return = $this->handleDeliveredEvent($jsonEvent);
                    break;
                case 'bounced':
                    $return = $this->handleBouncedEvent($jsonEvent);
                    break;
                default:
                    $return = $this->handleGenericEvent($jsonEvent);
                    break;
            }
        return $return;
    }

    /**
     * @param StdClass $event
     * @return string
     */
    private function handleProcessedEvent(StdClass $event)
    {
        $data = '[' . date('Y-m-d H:i:s', $event->timestamp) . '] [Processed] Message id: ' . $event->sg_event_id;
        return $data;
    }

    /**
     * @param StdClass $event
     * @return string
     */
    private function handleGenericEvent(StdClass $event)
    {
        $data = '[' . date('Y-m-d H:i:s', $event->timestamp) . '] [Generic: '. $event->event .'] Message id: ' . $event->sg_event_id;
        return $data;
    }

    /**
     * @param StdClass $event
     * @return string
     */
    private function handleDeliveredEvent(StdClass $event)
    {
        $data = '[' . date('Y-m-d H:i:s', $event->timestamp) . '] [Delivered] Message id: ' . $event->sg_event_id;
        return $data;
    }

    /**
     * @param StdClass $event
     * @return string
     */
    private function handleClickedEvent(StdClass $event)
    {
        $data = '[' . date('Y-m-d H:i:s', $event->timestamp) . '] [Clicked] Message id: ' . $event->sg_event_id;
        return $data;
    }

    /**
     * @param StdClass $event
     * @return string
     */
    private function handleBouncedEvent(StdClass $event)
    {
        $data = '[' . date('Y-m-d H:i:s', $event->timestamp) . '] [Bounced] Message id: ' . $event->sg_event_id;
        return $data;
    }
}

/**
 */

/**
 * We receive the data as raw JSON, decode it so we can work with something.
 */
$rawData = file_get_contents("php://input");
$jsonEvents = json_decode($rawData);

$webhook = new Webhook();

foreach ($jsonEvents as $jsonEvent) {
    echo $webhook->processEvent($jsonEvent) . PHP_EOL;
}
