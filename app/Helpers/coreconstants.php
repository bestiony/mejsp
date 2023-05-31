<?php


const INACTIVE_CAMPAIGN = 0;
const LAUNCHED_CAMPAIGN = 1;
const CANCELED_CAMPAIGN = 2;
const FINISHED_CAMPAIGN = 3;
const FAILED_CAMPAIGN = 4;
const RESUMEABLE_CAMPAIGN = 5;
const CAMPAIN_STATUSES = [
    INACTIVE_CAMPAIGN => 'غير نشطة',
    LAUNCHED_CAMPAIGN => 'انطلقت',
    CANCELED_CAMPAIGN => 'ملغاة',
    FINISHED_CAMPAIGN => 'منتهية',
    FAILED_CAMPAIGN => 'معطلة',
    RESUMEABLE_CAMPAIGN => 'جاهزة',
];


const EMAIL_TEMPLATES_DIRECTORY = 'views/admin/mail/uploaded/';
