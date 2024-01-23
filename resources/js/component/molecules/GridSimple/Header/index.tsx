import React from 'react';
import { SortTableHeadline } from '../../../../props/props';
import ButtonFAS from '../../../atoms/Buttons/ButtonFAS';
import H4 from '../../../atoms/Typography/H4';

const GridHeader: React.FC<React.PropsWithChildren<SortTableHeadline>> = (
  props: SortTableHeadline,
): JSX.Element => (
  <div className="grid-title no-border">
    {typeof props.lable !== 'undefined' && props.lable !== '' && props.lable !== null ? (
      <H4 label={props.lable} />
    ) : (
      <H4 className="no-border" />
    )}
    {props.showTableButtons === true || typeof props.showTableButtons === 'undefined' ? (
      <div className="tools">
        <ButtonFAS className="chevron-down" />
        <ButtonFAS className="cogs" data-toggle="modal" />
        <ButtonFAS className="sync" />
        <ButtonFAS className="times" />
      </div>
    ) : (
      ''
    )}
  </div>
);

export default GridHeader;
