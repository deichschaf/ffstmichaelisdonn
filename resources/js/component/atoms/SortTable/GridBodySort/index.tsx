import React from 'react';
import Select from 'react-select';
import { SortTableGridBodySort } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const GridBodySort: React.FC<React.PropsWithChildren<SortTableGridBodySort>> = (
  props: SortTableGridBodySort,
): JSX.Element => {
  if (props.showPaginationList === false && props.showSearchBox === false) {
    return <></>;
  }

  const optionPageMax = [
    { label: 10, value: 10 },
    { label: 25, value: 25 },
    { label: 50, value: 50 },
    { label: 100, value: 100 },
  ];
  return (
    <div className="row">
      <div className="col-md-6">
        {props.showPaginationList === true || typeof props.showPaginationList === 'undefined' ? (
          <ErrorBoundary>
            <Select
              name="example2_length"
              aria-controls="example2"
              className="select2-choice select2-wrapper span12 select2-offscreen"
              closeMenuOnSelect={false}
              options={optionPageMax}
            />
          </ErrorBoundary>
        ) : (
          ''
        )}
      </div>
      <div className="col-md-6">
        {props.showSearchBox === true || typeof props.showSearchBox === 'undefined' ? (
          <div className="dataTables_filter" id="example2_filter">
            <label>
              Search: <input type="text" aria-controls="example2" className="input-medium" />
            </label>
          </div>
        ) : (
          ''
        )}
      </div>
    </div>
  );
};

export default GridBodySort;
