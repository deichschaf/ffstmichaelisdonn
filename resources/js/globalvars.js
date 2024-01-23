class GlobalVars {
  JSDomain() {
    if (process.env.NODE_ENV === 'production') {
      return '';
    }
    return 'http://localhost:29279';
  }

  getHomepageTitle() {
    return 'Freiwillige Feuerwehr Sankt Michaelisdonn';
  }

  getHomepageStart() {
    return '2010';
  }

  getIsFiredepartment() {
    return true;
  }

  getIsFloDith() {
    return false;
  }

  getFilePath() {
    return '/fileadmin';
  }
}

export default new GlobalVars();
