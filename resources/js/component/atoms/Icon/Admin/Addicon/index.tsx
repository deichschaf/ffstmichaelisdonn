import React from 'react';
import { IconSetProps } from '../../../../../props/props';
import FAS from '../../FAS';

const Addicon: React.FC<React.PropsWithChildren<IconSetProps>> = (
  props: IconSetProps,
): JSX.Element => <FAS className="plus-circle" title={props.title} />;
export default Addicon;
