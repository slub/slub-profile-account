# TYPO3 Extension `slub_profile_account`

[![TYPO3](https://img.shields.io/badge/TYPO3-11-orange.svg)](https://typo3.org/)

SLUB profile service account extension for TYPO3.

## 1 Usage

### 1.1 Installation using Composer

The recommended way to install the extension is using [Composer][1].

Run the following command within your Composer based TYPO3 project:

```
composer require slub/slub-profile-account
```

## 2 Api

### 2.1 Routes

Please check the routes' configuration. You have to set the matching page (limitToPages). If not the routes will not work properly.
Furthermore, have a look at postman and import the "postman_collection" file. This explains the possible APIs very well.

### 2.2 Typoscript

| Setup / Constant                                               | Comment                         |
|----------------------------------------------------------------|---------------------------------|
| plugin.tx_slubprofile_account.settings.api.path.user           | Path to get user info / detail  |
| plugin.tx_slubprofile_account.settings.api.path.login          | Path to login                   |
| plugin.tx_slubprofile_account.settings.api.path.passwordUpdate | Path to change password         |
| plugin.tx_slubprofile_account.settings.api.path.pinUpdate      | Path to change pin              |
| plugin.tx_slubprofile_account.settings.api.path.loanCurrent    | Path to loan current            |
| plugin.tx_slubprofile_account.settings.api.path.loanHistory    | Path to loan history            |
| plugin.tx_slubprofile_account.settings.api.path.loanRenewal    | Path to loan loanRenewal        |
| plugin.tx_slubprofile_account.settings.api.path.reserveCurrent | Path to reserve current         |
| plugin.tx_slubprofile_account.settings.api.path.reserveDelete  | Path to delete reservation      |
| plugin.tx_slubprofile_account.settings.api.path.reserveHistory | Path to reserve history         |
| plugin.tx_slubprofile_account.settings.api.path.reserveHold    | Path to reserve hold            |
| plugin.tx_slubprofile_account.settings.api.path.dataDownload   | Path to data download           |
| plugin.tx_slubprofile_account.settings.cache.account.lifeTime  | Life time to cache account data |
| plugin.tx_slubprofile_account.settings.general.itemsPerPage    | Items per page for pagination   |

### 2.3 Update account data

To update data via external form you have to send an array called "account" via post with the following fields:

| Field name         | Comment    |
|--------------------|------------|
| EmailAddress       | Obligation |
| PostalAddress1     | Obligation |
| PostalAddress2     |            |
| PostalCity         | Obligation |
| PostalPostCode     | Obligation |
| PostalCountry      | Obligation |
| ResAddress1        |            |
| ResAddress2        |            |
| ResAddressCity     |            |
| ResAddressPostCode |            |
| ResAddressCountry  |            |

### 2.4 Update pin

To update pin via external form you have to send an array called "pin" via post with the following fields:

| Field name | Comment    |
|------------|------------|
| pin        | Obligation |
| pinRepeat  | Obligation |
| password   | Obligation |

### 2.5 Update password

To update password via external form you have to send a string called "password" via post with the following fields:

| Field name | Comment    |
|------------|------------|
| password   | Obligation |

[1]: https://getcomposer.org/

