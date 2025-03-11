<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <h2>Admin Logs</h2>
        <table border="1">
            <tr bgcolor="#00FF7F">
                <th>ID</th>
                <th>User Id</th>
                <th>User Type</th>
                <th>Log Status</th>
                <th>Log Date</th>
            </tr>
            <xsl:for-each select="//log">
                <tr>
                    <td>
                        <xsl:value-of select="@id" />
                    </td>
                    <td>
                        <xsl:value-of select="userId" />
                    </td>
                    <td>
                        <xsl:value-of select="userType" />
                    </td>
                    <td>
                        <xsl:value-of select="logStatus" />
                    </td>
                    <td>
                        <xsl:value-of select="logDate" />
                    </td>
                </tr>
            </xsl:for-each>
        </table>
    </xsl:template>

</xsl:stylesheet>