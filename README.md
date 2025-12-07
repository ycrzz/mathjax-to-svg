# Installation Guide

Follow the steps below to set up the required tools for MathJax rendering.

---

## 1. Install Node.js and NPM

```bash
make sure you have install php 7.4 on your ubuntu!
sudo apt update
sudo apt install -y nodejs npm

Verify the installation:
node -v
npm -v

##2. Install MathJax Node Packages
npm install mathjax-node mj-single

This will install:
mathjax-node – backend rendering engine for MathJax
mj-single – CLI tool for converting TeX into SVG/MathML/CHTML

##3. Verify ImageMagick (optional, only needed for SVG → PNG)
convert --version

If ImageMagick is not installed:
sudo apt install -y imagemagick

You're all set! If you need an example usage script or troubleshooting section, let me know.