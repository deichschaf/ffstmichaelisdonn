import React from 'react';
import Globalvars from '../../../globalvars';
import { PageTitleProps } from '../../../props/props';

const PageTitle: React.FC<React.PropsWithChildren<PageTitleProps>> = (
  props: PageTitleProps,
): JSX.Element => {
  function setTitle(newTitle): void {
    document.getElementsByTagName('title')[0].innerHTML = newTitle;
  }

  let fullTitle;
  const siteTitle = Globalvars.getHomepageTitle();
  if (props.pageTitle) {
    fullTitle = `${siteTitle} - ${props.pageTitle}`;
  } else {
    fullTitle = siteTitle;
  }
  setTitle(fullTitle);
  return <></>;
};

export default PageTitle;
