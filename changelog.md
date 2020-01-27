# Changelog of theTVDbAPI

## 1.x


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
