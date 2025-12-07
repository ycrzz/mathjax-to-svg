const mjAPI = require("mathjax-node");
mjAPI.config({
  MathJax: {
    SVG: {font: "TeX"},
  }
});
mjAPI.start();

const formula = process.argv[2];

mjAPI.typeset({
  math: formula,
  format: "TeX",
  svg: true
}, function (data) {
  if (data.errors) console.error(data.errors);
  console.log(data.svg);
});
