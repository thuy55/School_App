@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/minifyjs
php "%BIN_TARGET%" %*