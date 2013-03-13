hex_calc
=================

Hexadecimal color calculation plugin for ExpressionEngine. This was created to enable entry-stored hex colors to generate in-page styles that override call-to-action button colors. The plugin is used to accept the user-entered color code and generate a lighter or darker variant for border colors and hover state colors.

Parameters:
-----------

* source_color: specify a hexadecimal color. If you provide the #, the # will be returned with the new value. Default is 000000.
* percent: percentage of lightening or darkening. Default is 50.
* mode: specify either lighten or darken. 'lighten' is the default if no parameter is specified. Anything else is assumed darken.

Examples:
----------

This will lighten by 35%, outputting the # as well as new hex value

    {exp:hex_calc color="#16A527" percent="35"}

This will darken by 35% and will not include the hash

    {exp:hex_calc color="16A527" percent="35" mode="darken"}

Installation:
-------------

Create a subfolder within your third_party directory named 'hex_calc' and place the pi.hex_calc.php file there. That's it.