.. include:: ../../Includes.txt

==========================================================
Feature: #EXTBLOG-53 - Add SPAM protection to comment form
==========================================================

See https://jira.typo3.com/browse/EXTBLOG-53

See https://jira.typo3.com/browse/TE-12

Description
===========

The comment form use a honeypot field as spam protection. This means a new field is added to the comment form which must not be filled out. The field is set to hidden by JavaScript and only bots will fill out this field.


Impact
======

The template of the comment form has been changed.
Please add the the following code to your custom template if you not use the templates delivered by the extension:


.. code-block:: html

   <div class="form-group js-hp">
      <f:form.textfield id="hp" property="hp" class="form-control" additionalAttributes="{autocomplete: 'off'}" />
      <script type="text/javascript">
          var hp = document.getElementsByClassName('js-hp');
          for (var i=0; i<hp.length; i++) {
              hp[i].style = 'display: none;';
              hp[i].value = '';
          }
      </script>
   </div>

.. index:: Fluid, Frontend, JavaScript, PHP-API, TCA
