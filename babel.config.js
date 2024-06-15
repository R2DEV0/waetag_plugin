module.exports = {
    presets: [
      [
        '@babel/preset-env',
        {
          targets: {
            browsers: '> 0.25%, not dead', // Adjust the browser targets as needed
          },
          useBuiltIns: 'usage',
          corejs: 3,
        },
      ],
      '@babel/preset-react',
    ],
  };
  