import React from 'react';
import { LogoWithNameProps } from '../../../props/props';
import SVGIcon from '../../atoms/SVGIcon';

const LogoWithName: React.FC<React.PropsWithChildren<LogoWithNameProps>> = (
  props: LogoWithNameProps,
): JSX.Element => {
  if (typeof props.path === 'undefined') {
    return <></>;
  }
  return (
    <div className="logo">
      <span className="logoname">
        <SVGIcon svg="RLBS" alt="Retten - Löschen - Bergen - Schützen" />
        <span className="title" dangerouslySetInnerHTML={{ __html: props.name }} />
        {/* <span className="subtitle">Retten - Löschen - Bergen - Schützen</span> */}
      </span>
    </div>
  );
};
export default LogoWithName;
