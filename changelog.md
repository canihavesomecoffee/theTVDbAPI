# Changelog of theTVDbAPI

## 2.x

### 2.1.5 (20 February 2022)

Bugfix release (nullable types again)

### 2.1.4 (20 February 2022)

Bugfix release (nullable types again)

### 2.1.3 (20 February 2022)

**Breaking API changes update**

Note: If you were using this API for **movie artwork**, beware that as of the 23rd it'll change from relative to absolute!

* Routes
  * Changed
    * SearchRoute
      * Updated valid optional search arguments
  * New
    * SeriesRoute
      * Retrieve all artworks for serie
* Models
  * ArtworkExtendedRecord: status field
  * Character: peopleType and tagOptions fields
  * Company: companies removed, tagOptions added
  * EpisodeExtendedRecord: network is now a Company, nominations & studios added, companies removed
  * ListBaseRecord: image and imageIsFallback moved up from Extended record
  * MovieExtendedRecord: added companies, contentRatings, first_release, inspirations, production_countries, spoken_languages
  * NetworkBaseRecord: deleted
  * SearchResult: first_air_time, objectID, slug, studios added
  * SeasonExtendedRecord: deleted slug, abbreviation
  * SeriesExtendedRecord: airsTimeUTC, contentRatings, overview, seasonTypes added
  * Company: corrected fields (all are arrays of Company entries), specialEffects renamed to special_effects

### 2.1.2 (13 February 2022)

Bugfix release

* Fix
  * Add phpdocumentor/reflection-docblock as it's not installed when using `composer install --no-dev` (i.e. in production)

### 2.1.1 (24 January 2022)

Bugfix release

* Fix
  * all fields in ParentCompany are nullable.
  * all fields in CompanyRelationShip are nullable.
  * Character's personImgUrl is nullable.

### 2.1.0 (24 January 2022)

API additions

* Routes
  * SeriesRoute
    * allows passing episode id when searching
    * allows passing airdate when searching
* Models
  * EntityUpdate
    * New field: seriesId (for episode updates)
  * CompanyType
    * Changed field: id -> companyTypeId
    * Changed field: name -> companyTypeName
  * Links
    * New field: total_items
    * New field: page_size
  * Series
    * Base (and extended)
      * New field: episodes
    * Extended
      * New field: originalNetwork
      * New field: latestNetwork
      * New field: translations
      * New field: tags
  * Episodes
    * Base (and extended)
      * New field: seasonName
      * New field: finaleType
    * Extended
      * New field: companies
    * airsAfterSeason, airsBeforeSeason and airsBeforeEpisode have moved from the extended to the base record
  * Artwork
    * Extended
      * New field: tagOptions
  * Company
    * New field: companies
    * New field: parentCompany
  * SeasonType
    * New field: alternateName
  * New model: ParentCompany
  * New mode: CompanyRelationShip
  * Character
    * New field: personImgURL
  * ListExtendedRecord
    * New field: image
    * New field: imageIsFallback
  * ContentRating
    * New field: description
  * EntityType
    * Removed field: seriesId
    * New field: hasSpecials
  * ListBaseRecord
    * New field: score
  * MovieBaseRecord (and extended)
    * New field: runtime
    * New field: lastUpdated
  * PeopleBaseRecord
    * New field: nameTranslations
    * New field: overviewTranslations
  * PeopleExtendedRecord
    * New field: slug
  * SeasonBaseRecord (remain in Extended Record)
    * Removed field: abbreviation
    * Removed field: country
    * Removed field: slug
    * New field: companies
  * Inspiration
    * Renamed field: typeName -> type_name

### 2.0.14 (29 October 2021)

Bugfix release

* Fix
  * Company primary type is nullable.

### 2.0.13 (21 October 2021)

Bugfix release

* Fix
  * SeriesExtendedRecord also contains companies.

### 2.0.12 (20 October 2021)

Feature improvements, bugfix

* New
  * Series route has method to retrieve episodes in original language.

### 2.0.11 (12 October 2021)

Bugfix release

* Fix
  * Following the nullable name of a SeriesBaseRecord, the merging decision for fetching translated episodes no longer 
    operated correctly. This was corrected.

### 2.0.10 (10 October 2021)

Bugfix release

* Fix
  * Name of an SeriesBaseRecord can also be nullable (*sigh*).

### 2.0.9 (07 October 2021)

Bugfix release

* Fix
  * If episodes are not found in a fallback (or main) language, don't throw an exception. Only throw when both are
    throwing exceptions.

### 2.0.8 (03 October 2021)

Bugfix release

* Fix
  * Model class of SearchResults is not consistent with reality. (#24)
* New
  * Added methods to get localized name/overview in SearchResult model.

### 2.0.7 (02 October 2021)

Feature improvements, bugfix

* New
  * Artwork route
* Fix
  * allEpisodes now returns all episodes. Apparently the limit in one page is 500 rather than 100, causing this to be
    overlooked.
* Change
  * Bump format of phpunit.xml test.

### 2.0.6 (30 September 2021)

Bugfix release

* Fix
  * Another nullable entry for SeriesExtendedRecord

### 2.0.4 (28 September 2021) / 2.0.5

More bugfixes

* Fix
  * Episodes are not always present when retrieving them, so pass empty array in that case.

### 2.0.3 (28 September 2021)

More bugfixes

* Fix
  * Nullable entries in other models

### 2.0.2 (28 September 2021)

More bugfixes

* Fix
  * Nullable entries in other models

### 2.0.1 (28 September 2021)

First bugfix release for the new API.

* Fix
  * Nullable entries in Characters (who could've though?)

### 2.0.0 (27 September 2021)

First stable release for support of v4 of the TVDb API.

This version currently supports Authentication, Episodes, Series, Search, Update and Language API calls.
Support for other endpoints will be added in future releases.

* New: Minimal support for API v4.0.0 of theTVDb.
* Changed: Minimal PHP version is now 7.4
* Changed: Dependencies got bumped
  * Guzzle version 7 or newer
  * Symfony's components 5.3 or newer
  * PHPUnit 9 or newer (developers)

### 2.0.0b8 (26 September 2021)

Ninth beta

* Fix
  * Issue with argument for series episode
* New
  * Re-introduce multiple-language routes for Series

### 2.0.0b7 (25 September 2021)

Eighth beta

* Fix
  * Last array parsing issues

### 2.0.0b6 (25 September 2021)

Seventh beta (it doesn't stop...)

* Fix
  * Double checked all models (again)...

### 2.0.0b5 (25 September 2021)

Sixth beta

* Fix
  * Translation arrays can be empty...

### 2.0.0b4 (22 September 2021)

Fifth beta

* Fix
  * Fix array parsing of models
  * Update models to add correct model arrays

### 2.0.0b3 (19 September 2021)

Forth beta

* New
  * Series base and extended records have new fields and methods for average runtime & retrieving the imdb id.
  * Episode base has new fields to match API.

### 2.0.0b2 (18 September 2021)

Third beta

* Changed:
  * Updated updates controller to the latest revision of the API.
  * Updated series controller to the latest revision of the API.
* New:
  * SeriesAirDays now has a method to indicate if it airs every day, or no days at all.

### 2.0.0b1 (17 September 2021)

Second beta

* Changed: Bumped dependencies (Fixes #19)

### 2.0.0b (02 May 2021)

Major release for the new API of theTVDb.

* New: Beta support for API v4.0.0 of theTVDb.
* Changed: Minimal PHP version is now 7.4
* Changed: Dependencies got bumped

## 1.x

### 1.3.0 (17 September 2020)

- New: Allow Guzzle 7.x clients
- Changed: Allow PHPUnit version 9 next to version 8 to prepare for future PHP version bumps
- Changed: Update Travis configuration for PHP 7.4

### 1.2.8 (6 September 2020)

- Fix: Make sure the data elements are merged correctly when merging arrays of regular objects.

### 1.2.7 (6 September 2020)

- Fix: Make sure an array is returned when using the multi language wrapper when an array is required.

### 1.2.6 (8 March 2020)

- New: Broadened allowed version dependencies for the 3 Symfony packages (Dependabot).

### 1.2.5 (27 January 2020)

- Fix: Allow null for Banner, Slug and Status fields of BasicSeries (PR #8, #9)

### 1.2.4 (12 January 2020)

- Fix: Ignore ResourceNotFoundException's while retrieving data using the language wrapper.
- Fix: Added `getImages` method to the multi-language fallback to correct wrong return values.
- New: Added an example to retrieve banners. 

### 1.2.3 (7 January 2020)

- Fix: Make documentation on `getEpisodes` a bit clearer
- Changed: Updated the examples
- New: Added `getAllEpisodes` method to retrieve all episodes of a show at once.
- New: A changelog

### 1.2.2 (18 November 2019)

- Fix: Allow Null to be set on an firstAired and network (PR #5)

### 1.2.1 (17 November 2019)

- Fix: Correct some documentation
- Fix: Allow Null to be set on an airedEpisodeNumber


### 1.2.0 (16 November 2019)

- Fix: Allow null for series rating
- Changed: Revision bump of composer dependencies
- New: Support for theTVDb API version 3.x

### 1.1.1 (3 November 2019)

- Fix: TypeError in Actor model (#2)

### 1.1.0 (24 February 2019)

- New: Support for retrieving artwork in multiple languages (fallback)
- Changed: Minimal PHP version is now 7.2 instead of 7.1

### 1.0.9 (19 May 2018)

- Fix: TheTVDbAPI returns NULL in some cases of AiredSeason, whereas only integers were to be expected.

### 1.0.8 (14 April 2018)

- Fix: The API model describes seriesId as an 'int', reality yields an string.

### 1.0.7 (14 April 2018)

- Fix: Increase test coverage for episodes and series and fix related bug(s).

### 1.0.6 (10 April 2018)

- Fix: No longer causes issues when theTVDb returns integers where floats were expected.

### 1.0.5 (10 April 2018)

- Fix: a couple of wrongly typed documentation are corrected.
- Fix: added a missing description of a field.
- Changed: a couple of fields are now nullable

### 1.0.4 (10 April 2018)

- Changed: This release changes the way the data parser is initialized, so that the serializer now will use the PhpDocExtractor to infer the types of the objects. This fixes an issue that was discovered where an object inside an object wouldn't be correctly initialized. A test for this behaviour was added, and some bugs in the tests that came to light were also fixed.

### 1.0.3 (6 October 2017)

- Changed: The default merge behaviour for the fallback language generator has been modified to by default merge the classes now.

### 1.0.2 (10 September 2017)

- Fix: missing dependency causing a crash

### 1.0.1 (10 September 2017)

- Fix: Wrong method that caused most of the requests to return an HTTP status code of 405
- Fix: A failing test due to the microseconds introduced in php 7.1

### 1.0.0 (7 September 2017)

Initial release
