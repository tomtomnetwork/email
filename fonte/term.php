<?php

define('RESET_ALL', 0);
define('BOLD', 1);
define('DIM', 2);
define('UNDERLINE', 4);
define('BLINK', 5);
define('REVERSE', 7);
define('HIDDEN', 8);
define('RESET_BOLD', BOLD + 20);
define('RESET_DIM', DIM + 20);
define('RESET_UNDERLINE', UNDERLINE + 20);
define('RESET_REVERSE', REVERSE + 20);
define('RESET_HIDDEN', HIDDEN + 20);
define('DEFAULT_COLOR', 39);
define('BLACK', 30);
define('RED', 31);
define('GREEN', 32);
define('YELLOW', 33);
define('BLUE', 34);
define('MAGENTA', 35);
define('CYAN', 36);
define('LIGHT_GRAY', 37);
define('DARK_GRAY', BLACK + BLACK);
define('LIGHT_RED', RED + BLACK);
define('LIGHT_GREEN', GREEN + BLACK);
define('LIGHT_YELLOW', YELLOW + BLACK);
define('LIGHT_BLUE', BLUE + BLACK);
define('LIGHT_MAGENTA', MAGENTA + BLACK);
define('LIGHT_CYAN', CYAN + BLACK);
define('WHITE', LIGHT_GRAY + BLACK);

function write(string $text, int $foreground = 39, int $background = 39, int $style = 0) {
  $background += 10;
  echo "\e[{$style};{$foreground};{$background}m{$text}\e[0m";
}

function writeLn(string $text, int $foregroung = 39, int $background = 39, int $style = 0) {
  write(...func_get_args());
  echo "\n";
}