<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/">
        <html>
            <head>
                <title>Payment History</title>
            </head>
            <body>
                <link href="../css/purchasedItems.css" rel="stylesheet" type="text/css"/>
                <table>
                    <tr>
                        <td>Order No.</td>
                        <td>User ID</td>
                        <td>Item Code</td>
                        <td>Item Name</td>
                        <td>Item Desc</td>
                        <td>Item Price</td>
                        <td>Order Quantity</td>
                        <td>Total Price / Item</td>
                        <td>Ordered Date and Time</td>
                    </tr>
                    <xsl:for-each select="//table">
                        <tr>
                            <td>
                                <xsl:value-of select="column[@name = 'orderNo']"/>
                            </td>
                            <td>
                                <p><xsl:value-of select="column[@name = 'userID']"/></p>
                            </td>
                            <td>
                                <p><xsl:value-of select="column[@name = 'itemCode']"/></p>
                            </td>
                            <td>
                                <p><xsl:value-of select="column[@name = 'itemName']"/></p>
                            </td>
                            <td>
                                <p><xsl:value-of select="column[@name = 'itemDesc']"/></p>
                            </td>
                            <td>
                                <p><xsl:value-of select="column[@name = 'itemPrice']"/></p>
                            </td>
                            <td>
                                <p><xsl:value-of select="column[@name = 'itemQuantity']"/></p>
                            </td>
                            <td>
                                <p><xsl:value-of select="column[@name = 'multipliedPrice']"/></p>
                            </td>
                            <td>
                                <p><xsl:value-of select="column[@name = 'created_at']"/></p>
                            </td>
                            <br/>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
