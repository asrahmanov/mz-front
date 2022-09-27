const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('admin', './assets/admin.js')
    .autoProvidejQuery()
    .autoProvideVariables(
        {
            config: 'config',
        }
    )
    .enableVueLoader()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableStimulusBridge('./assets/controllers.json')
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
            config.plugins.push('@babel/plugin-proposal-class-properties');
        },
        {
            exclude: /node_modules/,
        }
    )
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3.8;
    })
;

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('main', './assets/main.js')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
            config.plugins.push('@babel/plugin-proposal-class-properties');
        },
        {
            exclude: /node_modules/,
        }
    )
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3.8;
    })

module.exports = Encore.getWebpackConfig();
