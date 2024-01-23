import React from 'react';
import { FooterModulesProps } from '../../../../props/props';
import FooterFlodithStatistic from './FooterFlodithStatistic';

const FooterModules: React.FC<React.PropsWithChildren<FooterModulesProps>> = (
  props: FooterModulesProps,
): JSX.Element => {
  if (typeof props.footer === 'undefined') {
    return <></>;
  }
  if (typeof props.footer.flodith === 'undefined') {
    return <></>;
  }
  return (
    <>
      {props.footer.flodith !== 'undefined' ? (
        <FooterFlodithStatistic footer={props.footer} />
      ) : (
        <></>
      )}
    </>
  );
};
export default FooterModules;
