import React, { useState } from 'react';
import Globalvars from '../../../globalvars';
import { AdminHeaderProps } from '../../../props/props';
import BurgerMenu from '../../atoms/Buttons/BurgerMenu';
import H1 from '../../atoms/Typography/H1';
import ErrorBoundary from '../errorboundary';

const AdminHeader: React.FC<React.PropsWithChildren<AdminHeaderProps>> = (
  props: AdminHeaderProps,
): JSX.Element => {
  const [showMenu, setShowMenu] = useState(false);

  function ShowMenu() {
    if (showMenu) {
      document.getElementById('bodyarea')?.classList.remove('open-menu-left');
      document.getElementById('main-menu-wrapper')?.classList.remove('scroll-content');
      document.getElementById('main-menu')?.classList.remove('visible');
    } else {
      document.getElementById('bodyarea')?.classList.add('open-menu-left');
      document.getElementById('main-menu-wrapper')?.classList.add('scroll-content');
      document.getElementById('main-menu')?.classList.add('visible');
    }
    setShowMenu(!showMenu);
  }

  return (
    <div className="header navbar navbar-inverse ">
      <div className="navbar-inner">
        <div className="header-seperation">
          <ul className="nav pull-left notifcation-center d-block d-sm-none d-sm-block d-md-none">
            <li className="dropdown">
              <ErrorBoundary>
                <BurgerMenu
                  onClick={() => {
                    ShowMenu();
                  }}
                />
              </ErrorBoundary>
            </li>
          </ul>
        </div>
        <div className="header-quick-nav">
          <H1 label={`Adminbereich - ${Globalvars.getHomepageTitle()}`} />
        </div>
      </div>
    </div>
  );
};
export default AdminHeader;
