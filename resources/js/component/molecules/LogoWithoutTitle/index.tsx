import React from 'react';
import {LogoWithoutTitleProps} from '../../../props/props';
import SVGIcon from '../../atoms/SVGIcon';

const LogoWithoutTitle: React.FC<React.PropsWithChildren<LogoWithoutTitleProps>> = (
  props: LogoWithoutTitleProps,
): JSX.Element => (
  <div className="logo">
    <span className="logoname">
      <SVGIcon svg="FlorianDithmarschen" alt="Florian Dithmarschen"/>
    </span>
  </div>
);
export default LogoWithoutTitle;
