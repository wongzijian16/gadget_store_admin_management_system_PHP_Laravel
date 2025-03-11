<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- TODO customize transformation rules 
         syntax recommendation http://www.w3.org/TR/xslt 
    -->
    <xsl:template match="/">
        <html>
            <head>
                <title>Productview.xsl</title>
            </head>
                 <body>
                <h1>Product List</h1>
                <style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    table, th, td {
                        border: 1px solid black;
                    }
                    th, td {
                        padding: 10px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                </style>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Image URL</th>
                            <th>Video URL</th>
                            <th>Category ID</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through each "table" element with name="products" -->
                        <xsl:for-each select="//table[@name='products']">
                            <tr>
                                <td><xsl:value-of select="column[@name='id']"/></td>
                                <td><xsl:value-of select="column[@name='name']"/></td>
                                <td><xsl:value-of select="column[@name='description']"/></td>
                                <td><xsl:value-of select="column[@name='price']"/></td>
                                <td><xsl:value-of select="column[@name='stock']"/></td>
                                <td><xsl:value-of select="column[@name='image_url']"/></td>
                                <td><xsl:value-of select="column[@name='video_url']"/></td>
                                <td><xsl:value-of select="column[@name='category_id']"/></td>
                                <td><xsl:value-of select="column[@name='created_at']"/></td>
                                <td><xsl:value-of select="column[@name='updated_at']"/></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
