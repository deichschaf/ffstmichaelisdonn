import React from 'react';
import { IconSetProps } from '../../../../props/props';
import FAS from '../FAS';

const DiabethsIcon: React.FC<React.PropsWithChildren<IconSetProps>> = (
  props: IconSetProps,
): JSX.Element => <FAS className="syringe" title={props.title} />;
export default DiabethsIcon;
