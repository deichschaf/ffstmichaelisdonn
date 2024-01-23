import React from 'react';
import { IconSetProps } from '../../../../../props/props';
import FAS from '../../FAS';

const Editicon: React.FC<React.PropsWithChildren<IconSetProps>> = (
  props: IconSetProps,
): JSX.Element => <FAS className="pencil-alt" title={props.title} />;
export default Editicon;
