const pluralize = require('pluralize')



module.exports = (plop) => {
  plop.setHelper('plural', txt => pluralize(txt))

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