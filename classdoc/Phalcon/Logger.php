<?php

namespace Phalcon;

abstract class Logger {
/** @type integer */
const SPECIAL = 9;

/** @type integer */
const CUSTOM = 8;

/** @type integer */
const DEBUG = 7;

/** @type integer */
const INFO = 6;

/** @type integer */
const NOTICE = 5;

/** @type integer */
const WARNING = 4;

/** @type integer */
const ERROR = 3;

/** @type integer */
const ALERT = 2;

/** @type integer */
const CRITICAL = 1;

/** @type integer */
const EMERGENCE = 0;

}