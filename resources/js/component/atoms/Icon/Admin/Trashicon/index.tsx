import React from 'react';
import { IconSetProps } from '../../../../../props/props';
import FAS from '../../FAS';

const Trashicon: React.FC<React.PropsWithChildren<IconSetProps>> = (
  props: IconSetProps,
): JSX.Element => <FAS className="trash-alt" title={props.title} />;
export default Trashicon;
