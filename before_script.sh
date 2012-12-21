export MWD=$PWD
cd src/toolbox/phpunit/tests/resources
python -m SimpleHTTPServer 8080 > /dev/null 2>&1 &
cd $MWD