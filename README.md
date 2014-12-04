# CSV to XML Converter Add-On for concrete5

Export page structure as importable XML (CIF) file from CSV file.

## Compatibility

5.6.2 - 5.6.x

## Example

### From CSV File

```
"page_name","page_path","page_pagetype","attr_meta_keywords","attr_exclude_sitemapxml","attr_select_tags"
"Lorem","/lorem","right_sidebar","Lorem, Ipsum",0,"composer"
"Ipsum","/about/upsum","left_sidebar",,1,"hello"
"Dolor","/lorem/dolor","full",,0,"world"
```

### To XML (concrete5-cif) File

```
<?xml version="1.0"?>
<concrete5-cif version="1.0">
	<pages>
		<page name="Lorem" path="/lorem" pagetype="right_sidebar">
			<attributes>
				<attributekey handle="meta_keywords">
					<value><![CDATA[Lorem, Ipsum]]></value>
				</attributekey>
				<attributekey handle="exclude_sitemapxml">
					<value><![CDATA[0]]></value>
				</attributekey>
				<attributekey handle="tags">
					<value><option>composer</option></value>
				</attributekey>
			</attributes>
		</page>
		<page name="Ipsum" path="/about/upsum" pagetype="left_sidebar">
			<attributes>
				<attributekey handle="meta_keywords">
					<value><![CDATA[]]></value>
				</attributekey>
				<attributekey handle="exclude_sitemapxml">
					<value><![CDATA[1]]></value>
				</attributekey>
				<attributekey handle="tags">
					<value><option>hello</option></value>
				</attributekey>
			</attributes>
		</page>
		<page name="Dolor" path="/lorem/dolor" pagetype="full">
			<attributes>
				<attributekey handle="meta_keywords">
					<value><![CDATA[]]></value>
				</attributekey>
				<attributekey handle="exclude_sitemapxml">
					<value><![CDATA[0]]></value>
				</attributekey>
				<attributekey handle="tags">
					<value><option>world</option></value>
				</attributekey>
			</attributes>
		</page>
	</pages>
</concrete5-cif>
```

## Prefixes

* `page_` Page data
* `attr_` Page attribute
  * `attr_select_` type: Select
  * `attr_file_` type: File

## ToDo

* Multiple select value

## License

The MIT License.
