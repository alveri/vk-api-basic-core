<?php

namespace App\Common;

class VKConstants
{
    const CALLBACK_TITLE = 'SJ Autopilot';
    const CALLBACK_VK_API_VERSION = '5.103';
    const VK_GROUP_PROVIDER = 'vk_group';
    const ALLOWED_EVENTS = [
        'message_new',
        'group_leave',
        'group_join'
    ];
}
