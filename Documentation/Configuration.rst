:navigation-title: Configuration

..  _configuration:

Configuration
=============

Not much configuration is needed. **Das** works out of the box and just a few constants are needed to be overwriten in order to modify the frontend output. This is explained in the :ref:`Themes <themes>` page.

If you don't want to use some of the new fields added to pages and content elements you can disable them via TSConfig. For instance, to disable the field *tx_das_customstyles* of the content elements:

..  code-block:: typoscript

   TCEFORM {
      tt_content {
         tx_das_customstyles.disabled = 1
      }
   }

Or if you want to disable it only for certain types of content elements, for example *shortcut* and *das_modal*:

..  code-block:: typoscript

   TCEFORM {
      tt_content {
         tx_das_customstyles
            types {
                shortcut.disabled = 1
                das_modal.disabled = 1
            }
      }
   }
