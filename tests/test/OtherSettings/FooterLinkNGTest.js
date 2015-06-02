/* @author: Prabuddha Chakraborty   */

module.exports = {

  'Step One : Enable Footer Link From Settings ' : function (browser){
    var data = browser.globals;
      browser
          .maximizeWindow()
          .wplogin(data.urls.LOGIN,data.USERNAME,data.PASSWORD)
          .openrtMediaSettings()
          .click(data.selectors.othersettings.OTHERSETTINGS)
          .pause(2000)
          //Disable Add a link to rtMedia in footer checkbox
          .getAttribute(data.selectors.othersettings.ADD_FOOTER_LINK, "checked", function(result) {
              if(result.value)
              {
                console.log('Disabling Footer link Checkbox');
                browser.click(data.selectors.othersettings.ADD_FOOTER_LINK);
                browser.click(data.selectors.SUBMIT);
              }
              else
              {
                  console.log('Footer link was already disabled');
              } })
            .pause(1000)

          },


    'step two: Check on Frontend ' : function (browser) {
        browser
            .moveToElement('#wp-admin-bar-site-name > a.ab-item',5,5)           //go to "Visit Site"
            .pause(100)
            .click('#wp-admin-bar-site-name > a.ab-item')
            .waitForElementVisible('body', 1500)
            .assert.elementNotPresent("body > div.rtmedia-footer-link > a")
            .wplogout()
            .end();

        }

  };
