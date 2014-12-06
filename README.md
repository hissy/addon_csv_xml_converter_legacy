# CSV to XML Converter Add-On for concrete5

Export page structure as importable XML (CIF) file from CSV file.

## Compatibility

5.6.2 - 5.6.x

## Example

### From CSV File

|page_name|page_path|page_pagetype|attr_meta_keywords|attr_exclude_sitemapxml|attr_select_tags|block_Main/content|
|----|----|----|----|----|----|----|
|Lorem|/lorem|right_sidebar|Lorem, Ipsum|0|hello//world|Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.|
|Ipsum|/about/ipsum|left_sidebar||1|hello||
|Dolor|/lorem/dolor|full||0|world||

```
"page_name","page_path","page_pagetype","attr_meta_keywords","attr_exclude_sitemapxml","attr_select_tags","block_Main/content"
"Lorem","/lorem","right_sidebar","Lorem, Ipsum",0,"hello//world","Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
"Ipsum","/about/ipsum","left_sidebar",,1,"hello",
"Dolor","/lorem/dolor","full",,0,"world",
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
        <page name="Ipsum" path="/about/ipsum" pagetype="left_sidebar">
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
        <page name="Dolor" path="/lorem/dolor" pagetype="full">
            <attributes>
                <attributekey handle="meta_keywords">
                    <value><![CDATA[]]></value>
                </attributekey>
                <attributekey handle="exclude_sitemapxml">
                    <value><![CDATA[0]]></value>
                </attributekey>
                <attributekey handle="tags">
                    <value>
                        <option>world</option>
                    </value>
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
