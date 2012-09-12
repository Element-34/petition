##SaunterPHP##

SaunterPHP is a Web Automation frameowork based on Selenium WebDriver. 

###Install###

    pear channel-discover element-34.github.com/pear
    pear install -f element-34/SaunterPHP

###Configuration###

Configuration files should not be commit to github as they will be specific to your environment. For this demo to work against the _We The People_ production site, rename _conf/saunter.inc.default_ to _conf/saunter.inc_.

###Script Discovery#

SaunterPHP select which scripts to run based on their _group_. All scripts should have at least one group; either

 * _shallow_ - smoke type scripts for which there will only be a few for your entire application
 * _deep_ - everything else

###Script Execution###

But you should not limit yourself to these.

    saunter.php --group shallow

###Sauce Labs OnDemand###

SaunterPHP integrates with the [Sauce Labs](https://saucelabs.com) OnDemand service. To enable it,

 * rename _conf/saucelabs.inc.default_ to _conf/saucelabs.inc_
 * put your username and api in that file
 * in saunter.inc set _sauce.ondemand_ to _true_
 * specify your _os_, _browser_ and _browser-version_ per their [OS-Browser Combinations](https://saucelabs.com/docs/browsers)

###Reports###

A log of the script run is stored in a timestamped file in _logs_. At the completion of the run, the file is copied to _latest.xml_. This is the file you point your CI server at for reporting purposes.