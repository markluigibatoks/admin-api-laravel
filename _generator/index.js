const pluralize = require('pluralize')
const _ = require('lodash')

module.exports = (plop) => {
  plop.setHelper('plural', txt => pluralize(txt))
  plop.setHelper('pluralSnakeCase', txt => _.snakeCase(pluralize(txt)))

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
        path: '../repositories/{{ kebabCase name}}-repository.ts',
        templateFile: './templates/repositories/index.hbs',
      }
    ]
  });
};