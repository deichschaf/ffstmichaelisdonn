import React from 'react';
import { AllPictureProps } from '../../../../props/props';

const PictureImageOnly: React.FC<React.PropsWithChildren<AllPictureProps>> = (
  props: AllPictureProps,
): JSX.Element => (
  <picture className={props.className}>
    <img src={props.img} alt={props.alt} />
  </picture>
);
export default PictureImageOnly;
