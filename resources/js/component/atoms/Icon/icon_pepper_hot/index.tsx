import React, { FC } from 'react';
import classNames from 'classnames';
import PepperHotSVG from '../../../svgs/pepper-hot.svg';
import Colors from '../../../types/colors';
import convertColorToColorClasses from '../../../utils/convertColorToColorClasses';

export interface PepperHotProps {
  className?: string;
  color?: Colors;
}

const PepperHot: FC<React.PropsWithChildren<PepperHotProps>> = (props: PepperHotProps) => (
  <span
    className={classNames(
      'pepperhot',
      convertColorToColorClasses(props.color || 'gray'),
      props.className,
    )}
  >
    <PepperHotSVG />
  </span>
);
export default PepperHot;
