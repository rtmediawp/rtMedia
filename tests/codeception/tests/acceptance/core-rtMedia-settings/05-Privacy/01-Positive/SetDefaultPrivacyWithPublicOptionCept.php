<?php

/**
* Scenario : To set default privacy with public.
*/

    use Page\Login as LoginPage;
    use Page\Logout as LogoutPage;
    use Page\Constants as ConstantsPage;
    use Page\UploadMedia as UploadMediaPage;
    use Page\DashboardSettings as DashboardSettingsPage;
    use Page\BuddypressSettings as BuddypressSettingsPage;

    $status = 'status public..';

    $I = new AcceptanceTester( $scenario );
    $I->wantTo( 'To check if the user is allowed to set default privacy with public option' );

    $loginPage = new LoginPage( $I );
    $loginPage->loginAsAdmin( ConstantsPage::$userName, ConstantsPage::$password );

   // Allow upload from Activity Stream must be enabled
    $settings = new DashboardSettingsPage( $I );
    $settings->gotoTab( ConstantsPage::$buddypressTab, ConstantsPage::$buddypressTabUrl );
    $settings->verifyEnableStatus( ConstantsPage::$strMediaUploadFromActivityLabel, ConstantsPage::$mediaUploadFromActivityCheckbox );
    // Go to Privacy tab
    $I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings/#rtmedia-privacy' );
//  $settings->gotoTab( ConstantsPage::$privacyTab, ConstantsPage::$privacyTabUrl );
    $settings->verifyEnableStatus( ConstantsPage::$privacyLabel, ConstantsPage::$privacyCheckbox );
    $settings->verifyEnableStatus( ConstantsPage::$privacyUserOverrideLabel, ConstantsPage::$privacyUserOverrideCheckbox );
    $settings->verifySelectOption( ConstantsPage::$defaultPrivacyLabel, ConstantsPage::$publicRadioButton );

    $buddypress = new BuddypressSettingsPage( $I );
    $buddypress->gotoActivityPage( ConstantsPage::$userName );

    $I->seeElementInDOM( ConstantsPage::$privacyDropdown );

    $uploadmedia = new UploadMediaPage( $I );
    $uploadmedia->postStatus( $status );
    $I->wait( 5 );

    $logout = new LogoutPage( $I );
    $logout->logout();

    $buddypress->gotoActivityPage( ConstantsPage::$userName );
    $I->see( $status );

?>
