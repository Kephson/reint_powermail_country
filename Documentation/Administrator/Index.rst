﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

Target group: **Administrators**

This extension is easy to install and to configure.
It depends on the powermail extension but it can be installed without powermail, because it adds only ViewHelpers.


.. _admin-installation:

Installation
------------

To install the extension, perform the following steps:

#. Go to the Extension Manager
#. Install static_info_tables for English country names and execute the
#. Install other static_info_tables extensions (see all on :ref:`What does it do <what-it-does>`)
#. Execute the update scripts after installation of a static_info_tables extension for each extension to add the database entries!
#. Install the extension reint_powermail_country



.. figure:: ../Images/Administrator/installation.jpg
   :width: 800px
   :alt: Installation of static_info_tables

   Installation of static_info_tables

   Execute the update script after installation of a static_info_tables extension




.. _admin-configuration:

Configuration
-------------

#. Go to your country select template e.g. /yourPowermailTemplatesPath/Partials/Form/Field/Country.html
#. Insert the new namespace and change the select field like in the example below
#. Do not change the template in the powermail extension folder, because after an update you will loose it!!!


**Example Country.html template:**

::

        {namespace vh=In2code\Powermail\ViewHelpers}
        {namespace rvh=RENOLIT\ReintPowermailCountry\ViewHelpers}

        <f:comment>
            {vh:form.countries()} will try to get the country list from the extension static_info_tables (and _de, _fr etc...)
            If static_info_tables is not installed, a static list of countries and the ISO3 code will be shown in frontent
            If you want to change sorting, Value or Label, please install static_info_tables
        </f:comment>

        <div class="powermail_fieldwrap powermail_fieldwrap_type_country powermail_fieldwrap_{field.marker} {field.css} {settings.styles.framework.fieldAndLabelWrappingClasses}">
            <f:render partial="Form/FieldLabel" arguments="{_all}" />

            <div class="{settings.styles.framework.fieldWrappingClasses}">
                <f:switch expression="{rvh:languageCode()}">
                    <f:case value="de">
                        <f:form.select
                                property="{field.marker}"
                                options="{vh:form.countries(key:'isoCodeA2',value:'shortNameDe',sortbyField:'shortNameDe',sorting:'asc')}"
                                prependOptionLabel="{f:translate(key:'pleaseChoose')}"
                                class="powermail_country {settings.styles.framework.fieldClasses} {vh:validation.errorClass(field:field, class:'powermail_field_error')}"
                                value="{vh:misc.prefillField(field:field, mail:mail)}"
                                additionalAttributes="{vh:validation.validationDataAttribute(field:field)}"
                                id="powermail_field_{field.marker}" />
                    </f:case>
                    <f:defaultCase>
                        <f:form.select
                                property="{field.marker}"
                                options="{vh:form.countries(key:'isoCodeA2',value:'shortNameEn',sortbyField:'shortNameEn',sorting:'asc')}"
                                prependOptionLabel="{f:translate(key:'pleaseChoose')}"
                                class="powermail_country {settings.styles.framework.fieldClasses} {vh:validation.errorClass(field:field, class:'powermail_field_error')}"
                                value="{vh:misc.prefillField(field:field, mail:mail)}"
                                additionalAttributes="{vh:validation.validationDataAttribute(field:field)}"
                                id="powermail_field_{field.marker}" />
                    </f:defaultCase>
                </f:switch>
            </div>
        </div>
