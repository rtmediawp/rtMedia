<?php

/**
 * Scenario : set custom css when default rtmedia style is enabled.
 */
    use Page\Login as LoginPage;
    use Page\Constants as ConstantsPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $I = new AcceptanceTester( $scenario );
    $I->wantTo( 'set custom css style when default rtmedia style is enabled.' );

    $loginPage = new LoginPage( $I );
    $loginPage->loginAsAdmin();

    $settings = new DashboardSettingsPage( $I );
    $settings->gotoSettings( ConstantsPage::$customCssSettingsUrl );
    $verifyEnableStatusOfRtmediaDefaultStyleCheckbox = $settings->verifyStatus( ConstantsPage::$defaultStyleLabel, ConstantsPage::$defaultStyleCheckbox );

    if ( $verifyEnableStatusOfRtmediaDefaultStyleCheckbox ) {
        echo nl2br( ConstantsPage::$enabledSettingMsg . "\n" );
    } else {
        $settings->enableSetting( ConstantsPage::$defaultStyleCheckbox );
        $settings->saveSettings();
    }


    $settings->setValue( ConstantsPage::$customCssLabel, ConstantsPage::$cssTextarea, ConstantsPage::$customCssValue );
    // $settings->saveSettings();
    $I->executeJS( "jQuery('.rtm-button-container.bottom .rtmedia-settings-submit').click();" );
    $I->waitForText( 'Settings saved successfully!', 30 );
    $temp = $I->grabTextFrom( ConstantsPage::$cssTextarea );
    echo " \n Text area value = " . $temp;

    $I->runShellCommand('rm -rf app/storage/cache/*');
    $buddypress = new BuddypressSettingsPage( $I );
    $buddypress->gotoMedia();

    $optionDivColor = $I->executeJS('return $(".rtm-media-options").css("margin-bottom");');

    echo "\n Option div button color = ". $optionDivColor;
    echo "\n";
    $I->assertEquals( $optionDivColor, '20px' );


?>
© 2020 GitHub, Inc.