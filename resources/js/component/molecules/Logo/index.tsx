import React from 'react';
import { LogoProps } from '../../../props/props';
import PictureSourcSet from '../../atoms/Picture/SourceSet';
import { Link } from 'react-router-dom';

const Logo: React.FC<React.PropsWithChildren<LogoProps>> = (props: LogoProps): JSX.Element => {
  if (typeof props.path === 'undefined') {
    return <></>;
  }
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  return (
    <Link to={props.url} className="logo">
      <PictureSourcSet img={props.path} alt={props.alt} />
    </Link>
  );
};
export default Logo;
