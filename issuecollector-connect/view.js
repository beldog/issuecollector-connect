/**
 * Source from: https://developer.atlassian.com/static/connect/docs/latest/modules/jira/workflow-post-function.html
 */

AP.require(["jira"], function(jira) {
      // When the configuration is saved, this method is called. Return the values for your input elements.
      jira.WorkflowConfiguration.onSave(function() {
          var config = {
              "key": "val"
          };
          return JSON.stringify(config);
      });

      // Validate any appropriate input and return true/false
      jira.WorkflowConfiguration.onSaveValidation(function() {
          return true;
      });
  });
