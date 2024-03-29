# CSV to XML Converter Add-On for concrete5

Export page structure as importable XML (CIF) file from CSV file.

## Compatibility

5.7.4+ (Beta)

## Example

### From CSV File

|page_name|page_path|page_pagetype|page_template|attr_meta_keywords|attr_exclude_sitemapxml|attr_select_tags|block_Main/content|
|----|----|----|----|----|----|----|----|
|Lorem|/lorem|page|right_sidebar|Lorem, Ipsum|0|hello//world|Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.|
|Ipsum|/about/ipsum|page|left_sidebar||1|hello||
|Dolor|/lorem/dolor|page|full||0|world||

```
"page_name","page_path","page_pagetype","page_template","attr_meta_keywords","attr_exclude_sitemapxml","attr_select_tags","block_Main/content"
"Lorem","/lorem","page","right_sidebar","Lorem, Ipsum",0,"hello//world","Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
"Ipsum","/about/ipsum","page","left_sidebar",,1,"hello",
"Dolor","/lorem/dolor","page","full",,,,

```

### To XML (concrete5-cif) File

```
<?xml version="1.0"?>
<concrete5-cif version="1.0">
    <pages>
        <page name="Lorem" path="/lorem" pagetype="page" template="right_sidebar">
            <attributes>
                <attributekey handle="meta_keywords">
                    <value><![CDATA[Lorem, Ipsum]]></value>
                </attributekey>
                <attributekey handle="exclude_sitemapxml">
                    <value><![CDATA[0]]></value>
                </attributekey>
                <attributekey handle="tags">
                    <value>
                        <option>hello</option>
                        <option>world</option>
                    </value>
                </attributekey>
            </attributes>
            <area name="Main">
                <block type="content">
                    <data table="btContentLocal">
                        <record>
                            <content><![CDATA[Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.]]></content>
                        </record>
                    </data>
                </block>
            </area>
        </page>
        <page name="Ipsum" path="/about/ipsum" pagetype="page" template="left_sidebar">
            <attributes>
                <attributekey handle="meta_keywords">
                    <value><![CDATA[]]></value>
                </attributekey>
                <attributekey handle="exclude_sitemapxml">
                    <value><![CDATA[1]]></value>
                </attributekey>
                <attributekey handle="tags">
                    <value>
                        <option>hello</option>
                    </value>
                </attributekey>
            </attributes>
        </page>
        <page name="Dolor" path="/lorem/dolor" pagetype="page" template="full">
            <attributes>
                <attributekey handle="meta_keywords">
                    <value><![CDATA[]]></value>
                </attributekey>
                <attributekey handle="exclude_sitemapxml">
                    <value><![CDATA[]]></value>
                </attributekey>
                <attributekey handle="tags">
                    <value><option/></value>
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

## License

The MIT License.
