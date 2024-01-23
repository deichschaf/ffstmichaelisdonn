import React from 'react';
import Globalvars from '../../../globalvars';
import { HeaderProps } from '../../../props/props';
import LayoutContainer from '../../atoms/Layout/LayoutContainer';
import HeaderNavigation from '../../molecules/HeaderNavigation';
import HeaderTitleContact from '../../molecules/HeaderTitleContact';
import LogoWithName from '../../molecules/LogoWithName';
import ErrorBoundary from '../errorboundary';

const Header: React.FC<React.PropsWithChildren<HeaderProps>> = (
  props: HeaderProps
): JSX.Element => (
  <ErrorBoundary>
    <header className="wrapper">
      <div className="top">
        {Globalvars.getIsFiredepartment() ? (
          <LayoutContainer>
            <LogoWithName
              name={Globalvars.getHomepageTitle()}
              path="/fileadmin/rlbs.svg"
              alt="Logo"
            />
          </LayoutContainer>
        ) : (
          <>
            {typeof props.header !== 'undefined' ? (
              <HeaderTitleContact header={props.header} />
            ) : (
              <></>
            )}
          </>
        )}
      </div>
      {typeof props.header !== 'undefined' && typeof props.header.mainnavi !== 'undefined' ? (
        <>
          <HeaderNavigation mainnavi={props.header.mainnavi} />
        </>
      ) : (
        <></>
      )}
    </header>
  </ErrorBoundary>
);
export default Header;
