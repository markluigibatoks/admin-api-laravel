const pluralize = require('pluralize');
const _ = require('lodash');

module.exports = (plop) => {
  plop.setHelper('plural', txt => pluralize(txt))
  plop.setHelper('pluralSnakeCase', txt => _.snakeCase(pluralize(txt)))
  plop.setHelper('pluralKebabCase', txt => _.kebabCase(pluralize(txt)))
  plop.setHelper('pluralPascalCase', txt => pascalCase(pluralize(txt)))

  plop.setGenerator('module', {
    description: 'application module logic',
    prompts: [{
      type: 'input',
      name: 'name',
      message: 'module name please'
    }],
    actions: [
      //Create Controller File
      {
        type: 'add',
        path: '../app/Http/Controllers/{{ pascalCase name}}Controller.php',
        templateFile: './templates/controller/index.hbs',
      },
      //Append api routes
      {
        type: 'append',
        path: '../routes/api.php',
        pattern: /\/\/apiResource/,
        templateFile: './templates/apiRoutes/index.hbs',
      },
      {
        type: 'append',
        path: '../routes/api.php',
        pattern: /\/\/controllers/,
        templateFile: './templates/apiRoutes/controllers.hbs',
      }
    ]
  });
};