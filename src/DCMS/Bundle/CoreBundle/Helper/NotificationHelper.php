<?php

namespace DCMS\Bundle\CoreBundle\Helper;

use Symfony\Component\HttpFoundation\Session\Session;

class NotificationHelper
{
    const SESSION_KEY = 'dcms_notification';

    protected $session;
    protected $messages;

    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->messages = $this->session->get(self::SESSION_KEY);
    }

    protected function addNotification($type, $message, $params)
    {
        if (!isset($this->messages[$type])) {
            $this->messages[$type] = array();
        }

        $message = call_user_func_array('sprintf', array_merge(array($message), $params));

        $this->messages[$type][] = $message;
        $this->session->set(self::SESSION_KEY, $this->messages);
    }

    protected function getNotificationsOfType($type)
    {
        $this->session->set(self::SESSION_KEY, array());
        return isset($this->messages[$type]) ? $this->messages[$type] : array();
    }

    public function info($message, $params = array())
    {
        $this->addNotification('info', $message, $params);
    }

    public function error($message, $params = array())
    {
        $this->addNotification('error', $message, $params);
    }

    public function getInfos()
    {
        return $this->getNotificationsOfType('info');
    }

    public function getErrors()
    {
        return $this->getNotificationsOfType('error');
    }
}
