import React, { FC } from 'react';
import classNames from 'classnames';
import { ReactComponent as KnifeSVG } from '../../../svgs/knife.svg';
import Colors from '../../../types/colors';
import convertColorToColorClasses from '../../../utils/convertColorToColorClasses';

export interface KnifeProps {
  className?: string;
  color?: Colors;
}

const Knife: FC<React.PropsWithChildren<KnifeProps>> = (props: KnifeProps) => (
  <span
    className={classNames(
      'knife',
      convertColorToColorClasses(props.color || 'gray'),
      props.className,
    )}
  >
    <KnifeSVG />
  </span>
);
export default Knife;
