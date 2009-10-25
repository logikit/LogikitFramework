function displayMenu()
{
    document.write('<p id="menuClose"><a href="javascript:;" onclick="$(\'#nav\').hide(\'slow\');">Close</a></p><div class="container">' +
                   '<div class="row tableHeader  bgHeading">' +
                   '<div class="dungeon quarter">' +
                   '&nbsp;' +
                   '</div>' +
                   '<div class="dungeon quarter">' +
                   'General Topics' +
                   '</div>' +
                   '<div class="dungeon quarter">' +
                   'Libraries' +
                   '</div>' +
                   '<div class="dungeon quarter">' +
                   'Helpers' +
                   '</div>' +
                   '<div class="dungeon">' +
                   '&nbsp;' +
                   '</div>' +
                   '</div>' +
                   
                   '<div class="row">' +
                   '<div class="dungeon quarter">' +
                   '<ul><li><a href="index.html">Home</a></li></ul><br />' +
                   '<span class="navTitle">Info</span><br/><br/>' +
                   '</ul><ul>' +
                   '<li><a href="requirements.html">Server Requirements</a></li>' +
                   '<li><a href="license.html">MIT License</a></li>' +
                   '<li><a href="credits.html">Credits</a></li>' +
                   '</ul><ul>' +
                   '<span class="navTitle">Installation</span><br/><br/>' +
                   '<ul><ul>' +
                   '<li><a href="download.html">Downloading LF</a></li>' +
                   '<li><a href="install.html">Installation Instructions</a></li>' +
                   '</ul><ul>' +
                   '<span class="navTitle">Introduction</span><br/><br/>' +
                   '<ul><ul>' +
                   '<li><a href="gettingStarted.html">Getting Started</a></li>' +
                   '<li><a href="features.html">LF Features</a></li>' +
                   '<li><a href="flowChart.html">Application Flow Chart</a></li>' +
                   '<li><a href="mvc.html">Model-View-Controller</a></li>' +
                   '</ul>' +
                   '</div>' +
                   '<div class="dungeon quarter">' +
                   '<ul>' +
                   '<li><a href="urls.html">LF URLs</a></li>' +
                   '<li><a href="controllers.html">Controllers</a></li>' +
                   '<li><a href="templates.html">Templates</a></li>' +
                   '<li><a href="views.html">Views</a></li>' +
                   '<li><a href="models.html">Models</a></li>' +
                   '<li><a href="helpers.html">Helpers</a></li>' +
                   '<li><a href="libraries.html">Using LF Libraries</a></li>' +
                   '<li><a href="creatingLibraries.html">Creating Your Own Libraries</a></li>' +
                   '<li><a href="creatingHelpers.html">Creating Your Own Helpers</a></li>' +
                    '<li><a href="enablingAjax.html">Using AJAX</a></li>' +
                   '<li><a href="forms.html">Forms</a></li>' +
                   '<li><a href="validators.html">Validators</a></li>' +
                   '<li><a href="generator.html">Using the Application Generator</a></li>' +
                   '<li><a href="autoloader.html">Auto-loading Resources</a></li>' +
                   '</ul>' +
                   '</div>' +
                   '<div class="dungeon quarter">' +
                   '<ul>' +
                    '<li><a href="benchmarking.html">Benchmarking Class</a></li>' +
                    '<li><a href="database.html">Database Class</a></li>' +
                    '<li><a href="language.html">Language Class</a></li>' +
                    '<li><a href="netClient.html">Net Client Class</a></li>' +
                    '<li><a href="validation.html">Validation Class</a></li>' +
                    '</ul>' +
                   '</div>' +
                   '<div class="dungeon quarter">' +
                   '<ul>' +
                   '<li><a href="ajax.html">AJAX Helper</a></li>' +
                   '<li><a href="message.html">Messages Helper</a></li>' +
                   '<li><a href="file.html">File Helper</a></li>' +
                    '</ul>' +
                   '</div>' +
                   '<div class="dungeon">' +
                   '&nbsp;' +
                   '</div>' +
                   '</div>' +
                   '</div>');
}