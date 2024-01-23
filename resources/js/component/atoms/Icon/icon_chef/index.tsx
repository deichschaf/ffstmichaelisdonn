import React, { FC } from 'react';
import classNames from 'classnames';
import { ReactComponent as ChefSVG } from '../../../svgs/chef.svg';
import Colors from '../../../types/colors';
import convertColorToColorClasses from '../../../utils/convertColorToColorClasses';

export interface ChefProps {
  className?: string;
  color?: Colors;
}

const Chef: FC<React.PropsWithChildren<ChefProps>> = (props: ChefProps) => (
  <span
    className={classNames(
      'chef',
      convertColorToColorClasses(props.color || 'gray'),
      props.className,
    )}
  >
    <ChefSVG />
  </span>
);
export default Chef;
