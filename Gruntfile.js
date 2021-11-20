const sass = require('node-sass');

module.exports = function(grunt) {

  grunt.initConfig({
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
      '../custom-fs-theme/library/js/*.js',
      'bower_components/chosen/chosen.jquery.js',
      'library/js/*.js',
      'library/admin/js/*.js'
      ]
    },
    sass: {
      options: {
        implementation: sass
      },
      dev: {
        options: {
          sourceMap: true
        },        
        files: {
          'library/dist/css/styles.css': ['library/scss/styles.scss'],
          'library/dist/admin/css/admin-styles.min.css': ['library/admin/scss/admin-styles.scss']
        } 
      },  
      prod: {
        options: {
          implementation: sass,
          style: 'compressed',
          sourceMap: false         
        },        
        files: {
          'library/dist/css/styles.css': 'library/scss/styles.scss',
          'library/dist/admin/css/admin-styles.min.css': 'library/admin/scss/admin-styles.scss'
        } 
      } 
    },
    browserify: {
        dist: {
          options: {
            transform: [['babelify', { 
              presets: ["es2015","stage-3"],
              extensions: [".js",".ts"] }],
              [ "browserify-shim" ]],
          },
          files: {
            'library/dist/js/scripts.min.js': [          
            'bower_components/chosen/chosen.jquery.js',
            'library/js/affix.js', 
            'library/js/scripts.js', 
            ]
          },
        },
        dev: {
          options: {
            transform: [['babelify', { 
              presets: ["es2015","stage-3"],
              extensions: [".js",".ts"] }],
              [ "browserify-shim" ]],
            // browserifyOptions: {
            //   debug: true
            // },
            // sourceMap :{
            //   url: "scripts.min.js.map",
            //   // filename: "../../js/scripts.js"
            // },
          },
          files: {
            'library/dist/js/scripts.min.js': [
            'bower_components/chosen/chosen.jquery.min.js',
            'library/js/affix.js', 
            'library/js/scripts.js'
            ]
          }
        }
      },
    terser: {
      dist: {
        files: {
          'library/dist/js/scripts.min.js': [          
          'library/dist/js/scripts.min.js', 
          ]
        },
        options: {
          compress: {
            drop_console: true
          }
        }
      },
      dev: {
        files: {
          'library/dist/js/scripts.min.js': [
          'library/dist/js/scripts.min.js'
          ]
        },
        options: {
          // sourceMap: true,
          // JS source map: to enable, uncomment the lines below and update sourceMappingURL based on your install
          sourceMap :{
            root: "http://tony.local:8888/theme-dev/wp-content/themes/custom-fs-theme/",
            url: "scripts.min.js.map",
            // filename: "../../js/scripts.js"
          },
          // sourceMappingURL: "scripts.min.js.map"
        }     
      }
    },
    // autoprefixer
    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'ie 11', 'ios 6', 'android 4'],
        map: true
      },
      files: {
        expand: true,
        flatten: true,
        src: 'library/dist/css/*.css',
        dest: 'library/dist/css'
      },
    },
    // css minify
    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'library/dist/css',
          src: ['*.css', '!*.min.css'],
          dest: 'library/dist/css',
          ext: '.css'
        }]
      }
    },   
    grunticon: {
      myIcons: {
        files: [{
          expand: true,
          cwd: 'library/img',
          src: ['*.svg', '*.png'],
          dest: "library/dist/img"
        }],
        options: {
          enhanceSVG: true
        }
      }
    },
    version: {
      assets: {
        files: {
          'functions.php': ['library/dist/css/styles.css', 'library/dist/js/scripts.min.js']
        }
      }        
    },
    watch: {
      sass: {
        files: [
        'library/scss/**/*.scss',
        'library/admin/scss/*.scss'
        ],
        tasks: ['clean:css', 'sass:dev', 'version', ]
      },

      js: {
        files: [
        '<%= jshint.all %>'
        ],
        tasks: ['clean:js','browserify:dev', 'terser:dev', 'version']
      }

    },
    browserSync: {
      dev: {
        bsFiles: {
          src : [
          'library/dist/css/*',
          'library/admin/css/*',
          'library/dist/js/*',
          'library/admin/js/*',
          '**/*.php'
          ]
        },
        options: {
          watchTask: true,
          proxy: "tony.local:8888/theme-dev/"
        }
      }
    },
    clean: {
      dist: [
      'library/dist/css',
      'library/dist/js'
      ],
      js: [
      'library/dist/js'
      ],
      css: [
      'library/dist/css'
      ]
    }

  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-browserify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-wp-assets');
  grunt.loadNpmTasks('grunt-terser');
  grunt.loadNpmTasks('grunt-browser-sync');

  // Register tasks
  grunt.registerTask('default', ['browserSync', 'watch']);

  grunt.registerTask('build', [
    'clean:dist',
    'sass:prod',
    'browserify:dist', 
    'terser:dist',
    'autoprefixer',
    'cssmin',
    'version',

    ]);

};
