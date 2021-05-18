# FieldtypeOembed

## What it does

Store, collect and update oembed data from external sources. 
It used the great PHP Library [Essence](https://github.com/essence/essence) by Félix Girault and 
adds some processwire magic. This field is based on the example module FieldtypeEvents by 
Ryan and the TextformatterOEmbed by felixwahner. Thanks!

## Features
- Simple embedding of content via oembed endpoints and opengraph crawling
- Backend preview
- Searching in oembed data with $pages->find()
- Autoupdate with lazycron
- Support for [ProcessGraphQL](https://processwire.com/modules/process-graph-ql/) with the additional module *GraphQLFieldtypeOembed*

## Install

1. Copy the files for this module to /site/modules/FieldtypeOembed/
2. Execute the following command in the /site/modules/FieldtypeOembed/ directory.
   ```bash
   composer install
   ```
3. In admin: Modules > Refresh. Install Fieldtype > Oembed.
4. Create a new field of type Oembed, and name it whatever you would
   like. In our examples we named it simply "embed".
5. Add the field to a template and edit a page using that template.

## Configuration

`Modules` > `Configure` > `FieldtypeOembed`

### Lazycron
Setup the Lazycron schedule. The cache expiration is configurable in the field settings.

![Lazycron](https://user-images.githubusercontent.com/11630948/116866358-8e7b6000-ac0b-11eb-8793-a5a06546ff09.png)

### Custom Provider for Essence
You can configure your own `Oembed` or `OpenGraph` providers for Essence.  
[How to add custom providers (Essence Git)](https://github.com/essence/essence#configuration)

```json
{
	"getty": {
		"class": "OEmbed",
		"filter": "~gty\\.im/.+~i",
		"endpoint": "http://embed.gettyimages.com/oembed?url=:url"
	},
	"neuerituale": {
		"class": "OpenGraph",
		"filter": "~neuerituale\\.com.?~i"
	}
}
```
### Field settings
`Fields` > `embed` > `Details`
The FieldtypeOembed extends the FieldtypeURL (core). 
In addition to these settings, you can also set the cache time for the oembed data.
The lazycron will update the data.

![Fieldsettings](https://user-images.githubusercontent.com/11630948/116866356-8de2c980-ac0b-11eb-8d9f-dbcc9d751904.png)

### Field preview
![Fieldpreview](https://user-images.githubusercontent.com/11630948/116866352-8b806f80-ac0b-11eb-8842-d0f005b36354.png)

## API

### Returns the Oembed object (WireData).
```php
/** @var \ProcessWire\Oembed */
$page->embed
```

### Check emptiness
````php
/** @var boolean **/
$page->embed->empty
````

### Render
```php

/** @var string return the html from oembed result */
"$page->embed"
$page->embed->html
```

## The Oembed object
```php
// print_r($page->embed);

ProcessWire\Oembed Object
(
    [data] => Array
        (
            [empty] => false
            [url] => http://www.youtube.com/watch?v=dQw4w9WgXcQ
            [html] => '...'
            [type] => video
            [title] => Rick Astley - Never Gonna Give You Up (Video)
            [width] => 200
            [height] => 113
            [version] => 1.0
            [authorUrl] => https://www.youtube.com/user/RickAstleyVEVO
            [authorName] => RickAstleyVEVO
            [providerUrl] => https://www.youtube.com/
            [providerName] => YouTube
            [thumbnailUrl] => https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg
            [thumbnailWidth] => 480
            [thumbnailHeight] => 360
        )
)
````

## Find pages
You can query the oembed result fields
```php
$pages->find('embed.providerName=YouTube');
$pages->find('embed.width>=200');
```

## GraphQLFieldtypeOembed
You can query this field over ProcessGraphQL.  
Please install the additional module `GraphQLFieldtypeOembed`.

### Field definitions

```
myfield {
   empty: Boolean
   title: String
   authorName: String
   authorUrl: String
   type: String
   height: Int
   width: Int
   providerName: String
   providerUrl: String
   thumbnailHeight: Int
   thumbnailWidth: Int
   thumbnailUrl: String
   html: String
   url: String
}
```
