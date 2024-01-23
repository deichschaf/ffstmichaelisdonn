import React, { useState } from 'react';
import { useMediaQuery } from 'react-responsive';
import { HeaderNavigationProps } from '../../../props/props';
import HeaderNavType from '../../atoms/HeaderNavType';
import ErrorBoundary from '../../organisms/errorboundary';

const HeaderNavigation: React.FC<React.PropsWithChildren<HeaderNavigationProps>> = (
  props: HeaderNavigationProps
): JSX.Element => {
  const [showMenu, setShowMenu] = useState(false);
  const isDesktopOrLaptop = useMediaQuery({
    query: '(min-device-width: 1224px)',
  });
  const isBigScreen = useMediaQuery({ query: '(min-device-width: 1824px)' });
  const isTabletOrMobile = useMediaQuery({ query: '(max-width: 1224px)' });
  const isTabletOrMobileDevice = useMediaQuery({
    query: '(max-device-width: 1224px)',
  });
  const isPortrait = useMediaQuery({ query: '(orientation: portrait)' });
  const isRetina = useMediaQuery({ query: '(min-resolution: 2dppx)' });

  function buildNavi(navi) {
    if (typeof navi === 'undefined') {
      return <></>;
    }
    const data = [...navi];
    const list = data.map((item, idx) => (
      <HeaderNavType
        key={idx}
        title={item.title}
        subnavi={item.subnavi}
        id={item.id}
        link={item.link}
        target={item.target}
        rel={item.rel}
        options={item.options}
      />
    ));
    return list;
  }

  return (
    <ErrorBoundary>
      <nav className="navbar navbar-default navbar-expand-lg navbar-light bg-faded">
        <div className="container">
          <div className="navbar-brand">
            <button
              className="navbar-toggler hidden-md-up"
              data-toggle="collapse"
              data-target="#navbar-collapse-1"
              aria-controls="navbar-collapse-1"
              aria-expanded="false"
              title="Toggle navigation"
              onClick={() => setShowMenu(!showMenu)}
            >
              &#9776;
            </button>
          </div>
          <div
            className={`collapse navbar-collapse${showMenu ? ' show' : ''}`}
            id="navbar-collapse-1"
          >
            <ul className="navbar-nav main-navbar-nav" onClick={() => setShowMenu(!showMenu)}>
              {typeof props.mainnavi !== 'undefined' ? buildNavi(props.mainnavi) : <></>}
            </ul>
          </div>
        </div>
      </nav>
    </ErrorBoundary>
  );
};
export default HeaderNavigation;
