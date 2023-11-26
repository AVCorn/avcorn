module.exports = function(grunt) {

  grunt.initConfig({
    watch: {
      sass: {
        files: '**/*.scss',
        tasks: ['css'],
        options: {
          livereload: 35729
        }
      },
      all: {
        files: ['**/*.html'],
        options: {
          livereload: true
        }
      }
    },

    sass: {
      dev: {
        options: {
          style: 'expanded',
          loadPath: ['node_modules/foundation/scss']
        },
        files: {
          'public/assets/styles/footer.css': 'view/styles/footer.scss',
          'public/assets/styles/topbar.css': 'view/styles/topbar.scss'
        }
      }
    }
  });

  // Default task
  grunt.registerTask('default', ['watch']);
  grunt.registerTask('css', ['sass']);

  // Load up tasks
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

};
