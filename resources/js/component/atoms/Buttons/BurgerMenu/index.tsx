import React from 'react';
import classNames from 'classnames';
import ErrorBoundary from '../../../organisms/errorboundary';
import FAS from '../../Icon/FAS';

export interface BurgerMenuProps {
  naviOpen?: boolean;
  onClick?: (e: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void;
}

const BurgerMenu: React.FC<React.PropsWithChildren<BurgerMenuProps>> = (props: BurgerMenuProps) => (
  <ErrorBoundary>
    <button
      className={classNames('BurgerMenu', props.naviOpen && 'navitoggle--open')}
      data-qa="menuButton"
      onClick={props.onClick}
    >
      <FAS className="bars" />
    </button>
  </ErrorBoundary>
);

export default BurgerMenu;
