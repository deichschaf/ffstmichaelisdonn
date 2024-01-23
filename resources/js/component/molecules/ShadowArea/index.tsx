import React from 'react';
import { ShadowAreaProps } from '../../../props/props';

const ShadowArea: React.FC<React.PropsWithChildren<ShadowAreaProps>> = (
  props: ShadowAreaProps,
): JSX.Element => (
  /* if (typeof props.show_shadow === "undefined" || !props.show_shadow){
    return <></>;
  } */
  <div id="cover-spin" />
);
export default ShadowArea;
