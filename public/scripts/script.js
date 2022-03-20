function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    document.documentElement.className = themeName;
}

function toggleTheme() {
   if (localStorage.getItem('theme') === 'darkTheme'){
       setTheme('lightTheme');
   } else {
       setTheme('darkTheme');
   }
}

(function () {
   if (localStorage.getItem('theme') === 'darkTheme') {
       setTheme('darkTheme');
   } else {
       setTheme('lightTheme');
   }
})();